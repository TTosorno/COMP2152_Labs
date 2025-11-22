using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using COMP2139_ICE.Data;
using COMP2139_ICE.Areas.ProjectManagement.Models;

namespace COMP2139_ICE.Areas.ProjectManagement.Controllers;

[Area("ProjectManagement")]
[Route("api/[area]/[controller]")] // This creates a URL like /api/ProjectManagement/ProjectComment
[ApiController]
public class ProjectCommentController : ControllerBase
{
    private readonly ApplicationDbContext _context;

    public ProjectCommentController(ApplicationDbContext context)
    {
        _context = context;
    }

    // GET: api/ProjectManagement/ProjectComment/GetComments/5
    [HttpGet("GetComments/{projectId}")]
    public async Task<IActionResult> GetComments(int projectId)
    {
        var comments = await _context.ProjectComments
            .Where(c => c.ProjectId == projectId)
            .OrderByDescending(c => c.CreatedDate)
            .ToListAsync();

        return Ok(comments);
    }

    // POST: api/ProjectManagement/ProjectComment/AddComment
    [HttpPost("AddComment")]
    public async Task<IActionResult> AddComment([FromBody] ProjectComment comment)
    {
        if (!ModelState.IsValid)
        {
            return BadRequest(ModelState);
        }

        comment.CreatedDate = DateTime.UtcNow;
        _context.ProjectComments.Add(comment);
        await _context.SaveChangesAsync();

        return Ok(comment);
    }
}